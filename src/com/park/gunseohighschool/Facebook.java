package com.park.gunseohighschool;

import com.park.gunseohighschool.R;

import android.app.Activity;
import android.os.Bundle;
import android.view.Window;
import android.webkit.WebView;
import android.webkit.WebViewClient;

public class Facebook extends Activity {

	WebView myView;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		requestWindowFeature(Window.FEATURE_NO_TITLE);
		setContentView(R.layout.activity_facebook);
	
		myView=(WebView)findViewById(R.id.webView1);
		myView.loadUrl("https://www.facebook.com/pages/%EA%B5%B0%EA%B3%A0%EA%B5%AC%EB%A7%88-%EA%B5%B0%EC%84%9C%EA%B3%A0%EB%93%B1%ED%95%99%EA%B5%90-%EA%B5%AC%EC%84%9D%EA%B5%AC%EC%84%9D-%EC%95%8C%EC%95%84%EB%B3%B4%EB%A7%88/697456350265611?fref=ts");
		myView.setWebViewClient(new MyView());
	}

class MyView extends WebViewClient{
	public boolean shouldOverrideUrlLoading(WebView view,String url){
		view.loadUrl(url);
		return true;
	}
}
	


}
