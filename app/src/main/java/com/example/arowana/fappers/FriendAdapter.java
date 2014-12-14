package com.example.arowana.fappers;

import android.app.Activity;
import android.content.Context;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.RelativeLayout;
import android.widget.TextView;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;

import java.util.ArrayList;
import java.util.List;

/**
 * Created by Arowana on 10/11/2014.
 */
public class FriendAdapter extends ArrayAdapter<String> {
    final private String URL = Config.URL;

    private final ArrayList<String> values;
    private final Context context;
    private final int layoutId;

    public FriendAdapter(Context context, ArrayList<String> values) {
        super(context, R.layout.friend_layout, values);
        this.layoutId = R.layout.friend_layout;
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
        Button deleteFriendButton = (Button) v.findViewById(R.id.deleteButton);

        userTV.setText(values.get(position));

        deleteFriendButton.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View view){
                // Add data to nameValuePairs
                List<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>();
                nameValuePairs.add(new BasicNameValuePair("action", "deleteFriend"));
                nameValuePairs.add(new BasicNameValuePair("id", id));
                nameValuePairs.add(new BasicNameValuePair("idFriend", idFriend));

                HttpAsyncTask myTask = new HttpAsyncTask(URL, (AsyncResponse) FriendAdapter.this.context);
                //myTask.execute(nameValuePairs);
            }
        });
        */

        return v;
    }
}
