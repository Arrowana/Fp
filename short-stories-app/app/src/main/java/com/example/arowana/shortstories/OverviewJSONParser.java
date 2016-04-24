package com.example.arowana.shortstories;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;

public class OverviewJSONParser {
    private ArrayList<Ssoverview> ssList;

    public OverviewJSONParser(String jsonString){
        try {
            //Instanciation de l'objet JSON
            JSONObject jsonObject = new JSONObject(jsonString);

            //On recupère le tableau des overviews
            JSONArray jsonArray = jsonObject.getJSONArray("Overviews");

            ssList = new ArrayList<Ssoverview>();

            for (int i = 0; i < jsonArray.length(); i++)
            {
                String id = jsonArray.getJSONObject(i).getString("id");
                String title = jsonArray.getJSONObject(i).getString("title");
                String author = jsonArray.getJSONObject(i).getString("author");
                String note = jsonArray.getJSONObject(i).getString("note");

                ssList.add(new Ssoverview(id, title, author, note));
            }

        } catch (JSONException e) {
            e.printStackTrace();
        }
    }

    public ArrayList<Ssoverview> getList(){
        return ssList;
    }

}
