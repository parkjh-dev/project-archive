package com.park.gunseohighschool;

import android.os.Bundle;
import android.app.Activity;
import android.view.Menu;
import android.view.Window;

public class School_symbol extends Activity {

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		requestWindowFeature(Window.FEATURE_NO_TITLE);
		setContentView(R.layout.activity_school_symbol);
	}

}
