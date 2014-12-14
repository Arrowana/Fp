package com.example.arowana.fappers;

import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import com.google.android.gms.gcm.GoogleCloudMessaging;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;

public class LogScreenActivity extends GCMActivity implements AsyncResponse {

    final private String URL = Config.URL;

    private Button signinButton;
    private TextView usernameTV;
    private TextView passwordTV;
    private ProgressDialog progress;
    private Button registerButton;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_logscreen);

        //Instanciation des éléments graphiques
        signinButton = (Button) findViewById(R.id.signinButton);
        usernameTV = (TextView) findViewById(R.id.usernameTV);
        passwordTV = (TextView) findViewById(R.id.passwordTV);
        registerButton = (Button) findViewById(R.id.registerButton);

        //Read data in shared Preferences
        SharedPreferences prefs = this.getSharedPreferences("fappers", this.MODE_PRIVATE);
        //User stored
        if(prefs.contains("id")){
            Intent intent = new Intent(LogScreenActivity.this, MainActivity.class);
            Log.v("FP", "To MainActivity");
            startActivity(intent);
        }

        signinButton.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View view) {
                progress = ProgressDialog.show(LogScreenActivity.this, "Chargement", "Veuillez patienter");

                // Add data to nameValuePairs
                List<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>();
                nameValuePairs.add(new BasicNameValuePair("action", "signin"));
                nameValuePairs.add(new BasicNameValuePair("username", usernameTV.getText().toString()));
                nameValuePairs.add(new BasicNameValuePair("password", passwordTV.getText().toString()));
                nameValuePairs.add(new BasicNameValuePair("registration_id", getRegid()));

                passwordTV.setText("");

                HttpAsyncTask myTask = new HttpAsyncTask(URL, LogScreenActivity.this);
                myTask.execute(nameValuePairs);
            }
        });

        registerButton.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(LogScreenActivity.this, RegisterActivity.class);
                Log.v("FP", "To RegisterActivity");
                startActivity(intent);
            }
        });
    }


    @Override
    public void processFinish(String result){
        progress.dismiss();

        JSONObject jsonObject = null;
        String success = "0";
        String id = null;
        String username = null;
        String password = null;
        try {
            Log.v("FP", "Message reçu : " + result);
            jsonObject = new JSONObject(result);
            success = jsonObject.getString("success");
            id = jsonObject.getString("id");
            username = jsonObject.getString("username");
            password = jsonObject.getString("password");

        } catch (JSONException e){
            e.printStackTrace();
        }

        if(success.equals("1")){
            Intent intent = new Intent(LogScreenActivity.this, MainActivity.class);

            //Store user in SharedPreferences
            SharedPreferences prefs = this.getSharedPreferences("fappers", this.MODE_PRIVATE);
            SharedPreferences.Editor editor = prefs.edit();
            editor.putString("username", username);
            editor.putString("password", password);
            editor.putString("id", id);
            editor.commit();

            startActivity(intent);
        }
        else if (success.equals("0")){
            Toast.makeText(this, "Wrong username or password", Toast.LENGTH_LONG).show();
        }
    }
}
