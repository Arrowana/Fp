package com.example.arowana.shortstories;

import java.util.ArrayList;

import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.ListView;

public class OverviewActivity extends Activity implements AsyncResponse {

	private ListView lv;
	private ArrayList<Ssoverview> ssList;
    private ProgressDialog progress;

    @Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_overview);

        //Recuperation de l'intent
        Intent intent = getIntent();
        //Recuperation de l'extra jsonString
        String jsonString = intent.getStringExtra("jsonResult");

        //Recupération du ArrayList par parsing du jsonString par la classe OverviewJSONParser
        ssList = new OverviewJSONParser(jsonString).getList();

        //Ajout d'un overview Default
		Ssoverview ss1 = new Ssoverview("999","Default", "Default", "0");
		ssList.add(ss1);

		//Declaration de l'adapter avec le layout et la ssList
		CustomAdapter adapter = new CustomAdapter(this, R.layout.overview, ssList);

        //Recuperation du dashboard
        lv = (ListView) findViewById(R.id.dashboard);
		lv.setAdapter(adapter);
		
		lv.setOnItemClickListener(new OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> arg0, View v, int position, long arg3) {
                //Recuperation de l'id de la nouvelle
                String id = ssList.get(position).getId();

                /*
                intent.putExtra("id", id);
    	        intent.putExtra("title", ssList.get(position).getTitle());
    	        intent.putExtra("author", ssList.get(position).getAuthor());
                */

                progress = ProgressDialog.show(OverviewActivity.this, "Chargement", "Veuillez patienter");

                HttpAsyncTask myTask = new HttpAsyncTask("http://shortstory.olympe.in/androidJSONID.php", OverviewActivity.this);
                myTask.execute("id", id);
            }
        });
		Log.v("SS", "Fin de onCreate");
	}

    @Override
    public void processFinish(String result) {
        Log.v("SS", "Yolo la methode dans l'Activity fonctionne");
        Log.v("SS", "Reponse reçue :");
        Log.v("SS", result);

        progress.dismiss();

        Intent intent = new Intent(OverviewActivity.this, ShortStoryActivity.class);
        //On passe le String JSON à l'activity suivante
        intent.putExtra("jsonResult", result);
        startActivity(intent);
    }
}
