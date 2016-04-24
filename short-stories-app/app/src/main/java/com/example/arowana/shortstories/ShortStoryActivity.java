package com.example.arowana.shortstories;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.widget.TextView;

import org.json.JSONException;
import org.json.JSONObject;

public class ShortStoryActivity extends Activity {
    private String title;
    private String text;
    private String author;

    @Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.ssa);
		
		//Recuperation de l'intent
		Intent intent = getIntent();

        String jsonString = intent.getStringExtra("jsonResult");

        //Parsing du JSON fait comme un porc à arranger plus tard
        try {
            JSONObject jsonObject = new JSONObject(jsonString);
            title = jsonObject.getString("title");
            author = jsonObject.getString("author");
            text = jsonObject.getString("text");
        } catch (JSONException e) {
            e.printStackTrace();
        }

        TextView titleTV = (TextView) findViewById(R.id.title);
		titleTV.setText(title);
		
		TextView authorTV = (TextView) findViewById(R.id.author);
		authorTV.setText(author);

        TextView textTV = (TextView) findViewById(R.id.text);
        textTV.setText(text);

	}
}
