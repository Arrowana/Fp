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

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;


public class RegisterActivity extends GCMActivity implements AsyncResponse{

    final private String URL = Config.URL;

    private TextView usernameTV;
    private TextView passwordTV;
    private TextView passwordCheckTV;
    private Button registerButton;
    private ProgressDialog progress;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_register);

        usernameTV = (TextView) findViewById(R.id.usernameTV);
        passwordTV = (TextView) findViewById(R.id.passwordTV);
        passwordCheckTV = (TextView) findViewById(R.id.passwordCheckTV);
        registerButton = (Button) findViewById(R.id.registerButton);

        registerButton.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View view) {
                boolean registerOK = true;

                if(!passwordTV.getText().toString().equals(passwordCheckTV.getText().toString())){
                    Toast.makeText(RegisterActivity.this, "Passwords are not both the same", Toast.LENGTH_LONG).show();
                    registerOK = false;

                } else if(!usernameTV.getText().toString().matches("[a-zA-Z0-9]*")){
                    Toast.makeText(RegisterActivity.this, "Special characters are not allowed (a-zA-Z0-9 only)", Toast.LENGTH_LONG).show();
                    registerOK = false;

                } else if(usernameTV.getText().toString().length() < 3){
                    Toast.makeText(RegisterActivity.this, "Username too short (3 characters min)", Toast.LENGTH_LONG).show();
                    registerOK = false;

                } else if(passwordTV.getText().toString().length() < 5){
                    Toast.makeText(RegisterActivity.this, "Password not safe because too short (5 characters min)", Toast.LENGTH_LONG).show();
                    registerOK = false;
                }

                /*
                *       If registration succeeds in
                * */
                if(registerOK){
                    progress = ProgressDialog.show(RegisterActivity.this, "Chargement", "Veuillez patienter");

                    // Add data to nameValuePairs
                    List<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>();
                    nameValuePairs.add(new BasicNameValuePair("action", "register"));
                    nameValuePairs.add(new BasicNameValuePair("registration_id", getRegid()));
                    nameValuePairs.add(new BasicNameValuePair("username", usernameTV.getText().toString()));
                    nameValuePairs.add(new BasicNameValuePair("password", passwordTV.getText().toString()));

                    HttpAsyncTask myTask = new HttpAsyncTask(URL, RegisterActivity.this);
                    myTask.execute(nameValuePairs);
                }

                passwordCheckTV.setText("");
            }
        });
    }

    /*
    *   Process data received from server API
    * */
    @Override
    public void processFinish(String result){
        Log.v("FP", "Message reçu : " + result);
        progress.dismiss();

        JSONObject jsonObject = null;
        String success = "0";
        String id = null;
        String username = null;
        String password = null;
        try {
            jsonObject = new JSONObject(result);
            success = jsonObject.getString("success");


        } catch (JSONException e) {
            e.printStackTrace();
        }

        //Analysis of data
        if(success.equals("1")){
            try {
                id = jsonObject.getString("id");
                username = jsonObject.getString("username");
                //password = jsonObject.getString("password");
            } catch (JSONException e) {
                e.printStackTrace();
            }

            Intent intent = new Intent(RegisterActivity.this, MainActivity.class);
            Log.v("FP", "Message reçu : " + result);

            //Store user in SharedPreferences
            SharedPreferences prefs = this.getSharedPreferences("fappers", this.MODE_PRIVATE);
            SharedPreferences.Editor editor = prefs.edit();
            editor.putString("username", username);
            //editor.putString("password", password);
            editor.putString("id", id);
            editor.commit();

            startActivity(intent);
        } else if(success.equals("0")){
            Toast.makeText(this, "Username already exists", Toast.LENGTH_LONG).show();
        } else{
            Toast.makeText(this, "Erreur de data", Toast.LENGTH_LONG).show();
        }
    }
}
