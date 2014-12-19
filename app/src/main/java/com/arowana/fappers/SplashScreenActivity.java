package com.arowana.fappers;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;

/**
 * Created by Arowana on 17/12/2014.
 */
public class SplashScreenActivity extends Activity {
    final private int splashTime = 1500;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        Handler handler = new Handler();
        handler.postDelayed(new Runnable() {
            @Override
            public void run() {
                Intent intent = new Intent(SplashScreenActivity.this, LogScreenActivity.class);
                startActivity(intent);
                SplashScreenActivity.this.finish();
            }
        }, splashTime);
    }
}
