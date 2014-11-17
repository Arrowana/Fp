package com.example.arowana.fappers;

import android.app.Activity;
import android.content.Context;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.RelativeLayout;
import android.widget.TextView;

import java.util.ArrayList;

/**
 * Created by Arowana on 10/11/2014.
 */
public class FriendAdapter extends ArrayAdapter<String> {
    private final ArrayList<String> values;
    private final Context context;
    private final int layoutId;

    public FriendAdapter(Context context, ArrayList<String> values) {
        super(context, R.layout.line_layout, values);
        this.layoutId = R.layout.line_layout;
        this.context = context;
        this.values = values;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent){
        View v = convertView;

        if (v == null) {
            v = ((Activity) context).getLayoutInflater().inflate(this.layoutId, parent, false);
        }

        //Recuperation de la view du layout et remplissage avec les donnees
        TextView userTV = (TextView) v.findViewById(R.id.userTV);
        userTV.setText(values.get(position));

        return v;
    }
}
