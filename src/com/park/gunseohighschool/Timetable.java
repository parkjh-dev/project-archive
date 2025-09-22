package com.park.gunseohighschool;

import com.park.gunseohighschool.R;

import android.os.Bundle;
import android.app.Activity;
import android.content.Intent;
import android.view.Menu;
import android.view.View;
import android.view.Window;
import android.view.View.OnClickListener;
import android.widget.Button;

public class Timetable extends Activity {

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		requestWindowFeature(Window.FEATURE_NO_TITLE);
		setContentView(R.layout.activity_timetable);
	
		Button Button1= (Button) findViewById(R.id.button1);
		Button1.setOnClickListener(new OnClickListener(){
			public void onClick(View v){	
				Intent myIntent=new Intent(Timetable.this,First.class);
				startActivity(myIntent);}});
		
		Button Button2= (Button) findViewById(R.id.button2);
		Button2.setOnClickListener(new OnClickListener(){
			public void onClick(View v){	
				Intent myIntent=new Intent(Timetable.this,Second.class);
				startActivity(myIntent);}});

	Button Button3= (Button) findViewById(R.id.button3);
	Button3.setOnClickListener(new OnClickListener(){
		public void onClick(View v){	
			Intent myIntent=new Intent(Timetable.this,Third.class);
			startActivity(myIntent);}});

	}
}
