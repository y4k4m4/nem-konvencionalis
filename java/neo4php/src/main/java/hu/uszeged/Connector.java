package hu.uszeged;

import com.google.gson.Gson;
import org.neo4j.driver.*;
import java.util.ArrayList;
import java.util.List;

public class Connector implements AutoCloseable {
    private final Driver driver;

    public Connector(String uri, String user, String password) {
        driver = GraphDatabase.driver(uri, AuthTokens.basic(user, password));
    }

    @Override
    public void close() throws RuntimeException {
        driver.close();
    }

    public List<String> doQuery(final String query){
        try (var session = driver.session()){
            var userQuery = session.executeWrite( uq -> uq.run(new Query(query)).list());
            List<String> jsonArray = new ArrayList<>();
            for (var queryResult: userQuery){
                jsonArray.add(new Gson().toJson(queryResult.asMap()));
            }
            return jsonArray;
        }
    }
}