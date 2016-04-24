package com.arowana.fappers;

/**
 * Created by Arowana on 18/12/2014.
 */
public class User {
    private String id;
    private String username;
    private String state;

    public User(String id, String username, String state){
        this.id = id;
        this.username = username;
        this.state = state;
    }

    public String getName() {
        return username;
    }

    public String getId() {
        return id;
    }

    public String getState() {
        return state;
    }
}

