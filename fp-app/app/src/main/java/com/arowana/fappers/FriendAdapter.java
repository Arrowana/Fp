package com.arowana.fappers;

import android.app.Activity;
import android.app.AlertDialog;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.util.Log;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.TextView;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;

import java.util.ArrayList;
import java.util.List;

/**
 * Created by Arowana on 10/11/2014.
 */
public class FriendAdapter extends ArrayAdapter<User> implements AsyncResponse{
    final private String URL = Config.URL;

    private ProgressDialog progress;
    private final ArrayList<User> friends;
    private final Context context;
    private final int layoutId;
    private final String id;

    public FriendAdapter(Context context, ArrayList<User> friends, String id) {
        super(context, R.layout.friend_layout, friends);
        this.layoutId = R.layout.friend_layout;
        this.context = context;
        this.friends = friends;
        this.id = id;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent){
        View v = convertView;

        if (v == null) {
            v = ((Activity) context).getLayoutInflater().inflate(this.layoutId, parent, false);
        }

        final User friend = this.friends.get(position);

        //Recuperation de la view du layout et remplissage avec les donnees
        TextView userTV = (TextView) v.findViewById(R.id.userTV);
        Button acceptButton = (Button) v.findViewById(R.id.acceptButton);
        final Button deleteFriendButton = (Button) v.findViewById(R.id.deleteButton);
        final TextView infoTextView = (TextView) v.findViewById(R.id.infoTextView);

        String state = friend.getState();

        infoTextView.setVisibility(View.GONE);
        acceptButton.setVisibility(View.GONE);
        deleteFriendButton.setVisibility(View.GONE);

        //Adapt item to state            WHY visibility from XML is not working?
        if(state.equals("pending")){
            infoTextView.setVisibility(View.VISIBLE);
            acceptButton.setVisibility(View.VISIBLE);
            deleteFriendButton.setVisibility(View.GONE);
            infoTextView.setText("accept?");
        } else if(state.equals("request")){
            infoTextView.setVisibility(View.VISIBLE);
            acceptButton.setVisibility(View.GONE);
            deleteFriendButton.setVisibility(View.GONE);
        } else if(state.equals("ok")){
            acceptButton.setVisibility(View.GONE);
            deleteFriendButton.setVisibility(View.VISIBLE);
        }

        userTV.setText(friend.getName());

        acceptButton.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View view){
                progress = ProgressDialog.show(FriendAdapter.this.context, "Chargement", "Veuillez patienter");

                // Add data to nameValuePairs
                List<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>();
                nameValuePairs.add(new BasicNameValuePair("action", "acceptFriend"));
                nameValuePairs.add(new BasicNameValuePair("id", id));
                nameValuePairs.add(new BasicNameValuePair("idFriend", friend.getId()));

                HttpAsyncTask myTask = new HttpAsyncTask(URL, FriendAdapter.this);
                myTask.execute(nameValuePairs);
            }
        });

        deleteFriendButton.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View view){

                new AlertDialog.Builder(FriendAdapter.this.context)
                        .setTitle("Delete")
                        .setMessage("Delete "+friend.getName()+"?")
                        .setView(view)
                        .setPositiveButton("Yes", new DialogInterface.OnClickListener() {
                            public void onClick(DialogInterface dialog, int whichButton) {
                                progress = ProgressDialog.show(FriendAdapter.this.context, "Chargement", "Veuillez patienter");

                                // Add data to nameValuePairs
                                List<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>();
                                nameValuePairs.add(new BasicNameValuePair("action", "deleteFriend"));
                                nameValuePairs.add(new BasicNameValuePair("id", id));
                                nameValuePairs.add(new BasicNameValuePair("idFriend", friend.getId()));

                                HttpAsyncTask myTask = new HttpAsyncTask(URL, (AsyncResponse) FriendAdapter.this.context);
                                myTask.execute(nameValuePairs);

                                deleteFriendButton.setVisibility(View.GONE);
                                infoTextView.setText("Friend deleted");
                                infoTextView.setVisibility(View.VISIBLE);
                            }
                        }).setNegativeButton("No", new DialogInterface.OnClickListener() {
                    public void onClick(DialogInterface dialog, int whichButton) {
                        // Do nothing.
                    }
                }).show();
            }
        });

        return v;
    }

    @Override
    public void processFinish(String result) {
        Log.v("FP", "Message reçu : " + result);
    }
}
