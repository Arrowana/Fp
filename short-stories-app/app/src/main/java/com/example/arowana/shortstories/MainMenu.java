package com.example.arowana.shortstories;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;

public class MainMenu extends Activity {
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_main_menu);
		
		Button searchButton = (Button) findViewById(R.id.recherche);
		
		searchButton.setOnClickListener(new OnClickListener(){
			@Override
			public void onClick(View arg0) {
				// TODO Auto-generated method stub
		        Intent intent = new Intent(MainMenu.this, SearchActivity.class);
		        startActivity(intent);	
			}
			
		});
	}
}
