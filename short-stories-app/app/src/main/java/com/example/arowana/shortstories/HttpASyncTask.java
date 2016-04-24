package com.example.arowana.shortstories;

import android.os.AsyncTask;
import android.util.Log;
import android.widget.Toast;

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

/* Cette classe n'est pas encore utilisée, pour l'instant on utilise directement cette classe dans
OverviewActivity pour éviter les problèmes de droit de thread
 */

public class HttpAsyncTask extends AsyncTask<String, Integer, Double> {
    private String url;
    private String result = "fail";
    private AsyncResponse delegate = null;
    private String responseBody;

    public HttpAsyncTask(String url, AsyncResponse del){
        this.delegate = del;
        this.url = url;
    }

    @Override
    protected Double doInBackground(String... params) {
        Log.v("SS", "Debut du HttpASyncTask");
        // Envoie les données
        postData(params[0], params[1]);
        return null;
    }

    @Override
    protected void onPostExecute(Double result) {
        delegate.processFinish(responseBody);
    }

    public void postData(String dataIndex, String data) {
        Log.v("SS", "Debut de postData");
        // Create a new HttpClient and Post Header
        HttpClient httpclient = new DefaultHttpClient();
        HttpPost httppost = new HttpPost(url);
        try {
            // Add your data
            List<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>();
            nameValuePairs.add(new BasicNameValuePair(dataIndex, data));

            httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));

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
