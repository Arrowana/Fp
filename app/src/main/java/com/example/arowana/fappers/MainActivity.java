package com.example.arowana.fappers;

import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.pm.PackageInfo;
import android.content.pm.PackageManager;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;

import com.google.android.gms.common.ConnectionResult;
import com.google.android.gms.common.GooglePlayServicesUtil;
import com.google.android.gms.gcm.GoogleCloudMessaging;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;

import java.io.IOException;
import java.util.ArrayList;
import java.util.List;

public class MainActivity extends GCMActivity implements AsyncResponse {

    final private String URL = Config.URL;

    public static final String EXTRA_MESSAGE = "message";
    public static final String PROPERTY_REG_ID = "registration_id";
    private static final String PROPERTY_APP_VERSION = "appVersion";
    private static final int PLAY_SERVICES_RESOLUTION_REQUEST = 9000;
    String SENDER_ID = "124659174182";

    /**
     * Tag used on log messages.
     */
    static final String TAG = "FP";

    private Button friendButton;
    private ProgressDialog progress;
    private TextView usernameTV;
    private Button logoutButton;
    private Button fpButton;

    private GoogleCloudMessaging gcm;
    private String regid;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        usernameTV = (TextView) findViewById(R.id.usernameTV);
        friendButton = (Button) findViewById(R.id.friendButton);
        logoutButton = (Button) findViewById(R.id.logoutButton);
        fpButton = (Button) findViewById(R.id.fpButton);

        //Read data in shared Preferences
        final SharedPreferences prefs = this.getSharedPreferences("fappers", this.MODE_PRIVATE);
        final String username = prefs.getString("username", "Error");
        final String id = prefs.getString("id", "Error");

        usernameTV.setText(username);

        friendButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                progress = ProgressDialog.show(MainActivity.this, "Chargement", "Veuillez patienter");

                // Add data to nameValuePairs
                List<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>();
                nameValuePairs.add(new BasicNameValuePair("action", "friends"));
                nameValuePairs.add(new BasicNameValuePair("id", id));

                HttpAsyncTask myTask = new HttpAsyncTask(URL, MainActivity.this);
                myTask.execute(nameValuePairs);
            }
        });

        fpButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Log.i(TAG, "fpButton onClick");
            }
        });

        logoutButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                //Remove data
                prefs.edit().remove("id").commit();
                prefs.edit().remove("username").commit();

                Intent intent = new Intent(MainActivity.this, LogScreenActivity.class);
                Log.v(TAG, "Logout");
                startActivity(intent);
            }
        });
    }

    /*
    *   Process data received from server fp API
    * */
    @Override
    public void processFinish(String result) {
        Intent intent = new Intent(MainActivity.this, FriendActivity.class);
        Log.v(TAG, "Message reçu : " + result);
        intent.putExtra("friendsJson", result);

        progress.dismiss();

        startActivity(intent);
    }

    @Override
    public void onResume() {
        super.onResume();
        checkPlayServices();
    }
}