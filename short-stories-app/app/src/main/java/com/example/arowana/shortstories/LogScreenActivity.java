package com.example.arowana.shortstories;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;

public class LogScreenActivity extends Activity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_logscreen);

        Button sendButton = (Button) findViewById(R.id.send);

        sendButton.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View arg0) {
                // TODO Auto-generated method stub
                Intent intent = new Intent(LogScreenActivity.this, MainMenu.class);
                startActivity(intent);
            }

        });
    }
}
