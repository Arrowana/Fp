package com.example.arowana.shortstories;

import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;

public class SearchActivity extends Activity implements AsyncResponse {
    private ProgressDialog progress;

    @Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_search);
		
		Button sendButton= (Button) findViewById(R.id.send);

		sendButton.setOnClickListener(new OnClickListener(){
			@Override
			public void onClick(View arg0) {
                //Affichage d'un ProgressDialog pendant le téléchargement
                progress = ProgressDialog.show(SearchActivity.this, "Chargement", "Veuillez patienter");

                HttpAsyncTask myTask = new HttpAsyncTask("http://shortstory.olympe.in/androidJSONAll.php", SearchActivity.this);
                myTask.execute("name","Parametre");
			}
		});
	}

    @Override
    public void processFinish(String result) {
        Log.v("SS", "Yolo la methode dans l'Activity fonctionne");
        Log.v("SS", "Reponse reçue :");
        Log.v("SS", result);

        progress.dismiss();

        Intent intent = new Intent(SearchActivity.this, OverviewActivity.class);
        //On passe le String JSON à l'activity suivante
        intent.putExtra("jsonResult", result);
        startActivity(intent);
    }
}
