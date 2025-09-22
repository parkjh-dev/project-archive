package com.park.gunseohighschool;

import com.park.gunseohighschool.R;

import android.app.Activity;
import android.os.Bundle;
import android.view.Window;
import android.webkit.WebView;
import android.webkit.WebViewClient;

public class GunWeb extends Activity {
	
	WebView MyView;
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		requestWindowFeature(Window.FEATURE_NO_TITLE);
		setContentView(R.layout.activity_gun_web);
	
		MyView=(WebView)findViewById(R.id.webView2);
		MyView.loadUrl("http://www.gunseo.hs.kr/main.php");
		MyView.setWebViewClient(new Myview());
	
	
	
	
	}

	class Myview extends WebViewClient{
		public boolean shouldOverrideUrlLoading(WebView view,String url){
			view.loadUrl(url);
			return true;
		}
	}


}
