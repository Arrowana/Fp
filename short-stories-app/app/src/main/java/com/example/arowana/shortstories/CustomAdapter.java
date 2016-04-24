package com.example.arowana.shortstories;

import android.app.Activity;
import android.content.Context;
import android.util.Log;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.RelativeLayout;
import android.widget.TextView;

import java.util.ArrayList;

public class CustomAdapter extends ArrayAdapter<Ssoverview> {

	private int layoutId;
	private Context context;
	private ArrayList<Ssoverview> list;

    private int test;

	public CustomAdapter(Context context, int resource, ArrayList<Ssoverview> ssList) {
		super(context, resource, ssList);
		this.layoutId = resource;
		this.context = context;
		this.list = ssList;
	}
	
	@Override
	public View getView(int position, View convertView, ViewGroup parent){
		View v = convertView;

		if (v == null) {
			v = (RelativeLayout) ((Activity) context).getLayoutInflater().inflate(this.layoutId, parent, false);
		}
        
		//On recupere le Ssoverview à la bonne position
		Ssoverview ss = this.list.get(position);
		
		if (ss != null) {
			//Recuperation de la view du layout et remplissage avec les donnees
			TextView titleTV=(TextView) v.findViewById(R.id.title);
			titleTV.setText(ss.getTitle());
			TextView authorTV=(TextView) v.findViewById(R.id.author);
			authorTV.setText(ss.getAuthor());
			TextView noteTV=(TextView) v.findViewById(R.id.note);
			noteTV.setText("Note : "+ss.getNote()+"/5");
			
		}
		return v;
	}

}
