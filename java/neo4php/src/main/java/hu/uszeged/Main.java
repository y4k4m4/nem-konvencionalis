package hu.uszeged;

import java.io.FileInputStream;
import java.util.Properties;
public class Main {

    public static void main(String[] args) {
        Properties prop = new Properties();
        try (FileInputStream fis = new FileInputStream("connect.config")) {
            prop.load(fis);
        } catch (Exception ex) {
            System.out.println("connect.config not found!");
            System.exit(1);
        }
        try (var connection = new Connector(
                prop.getProperty("connect.uri"),
                prop.getProperty("connect.user"),
                prop.getProperty("connect.password"))) {
            System.out.println(connection.doQuery(args[0]).toString());
        }
    }
}

