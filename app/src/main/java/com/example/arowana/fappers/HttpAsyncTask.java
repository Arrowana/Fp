package com.example.arowana.fappers;

import android.os.AsyncTask;
import android.util.Log;

import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.util.EntityUtils;

import java.io.IOException;
import java.util.ArrayList;
import java.util.List;

public class HttpAsyncTask extends AsyncTask<List<NameValuePair>, Integer, Double> {
    private String url;
    private String result = "fail";
    private AsyncResponse delegate = null;
    private String responseBody;

    public HttpAsyncTask(String url, AsyncResponse del){
        this.delegate = del;
        this.url = url;
    }

    @Override
    protected Double doInBackground(List<NameValuePair>... dataList) {
        Log.v("FP", "Debut du HttpASyncTask");
        // Envoie les données
        postData(dataList[0]);
        return null;
    }

    @Override
    protected void onPostExecute(Double result) {
        delegate.processFinish(responseBody);
    }

    public void postData(List<NameValuePair> dataList) {
        Log.v("FP", "Debut de postData");
        // Create a new HttpClient and Post Header
        HttpClient httpclient = new DefaultHttpClient();
        HttpPost httppost = new HttpPost(url);
        try {
            httppost.setEntity(new UrlEncodedFormEntity(dataList));

            // Execute HTTP Post Request
            HttpResponse response = httpclient.execute(httppost);

            //Recuperation de la réponse dans un String
            responseBody = EntityUtils.toString(response.getEntity());

        } catch (ClientProtocolException e) {
            // TODO Auto-generated catch block
        } catch (IOException e) {
            // TODO Auto-generated catch block
        }
    }
}

