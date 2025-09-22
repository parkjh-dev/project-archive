package com.park.gunseohighschool;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.Window;
import android.widget.Button;



public class Introduction extends Activity {

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		requestWindowFeature(Window.FEATURE_NO_TITLE);
		setContentView(R.layout.activity_introduction);
	
		Button symbol = (Button)this.findViewById(R.id.symbol);
		symbol.setOnClickListener(new OnClickListener() {
	    	@Override
			public void onClick(View arg0) {		
	    		Intent intent=new Intent(Introduction.this,School_symbol.class);
				startActivity(intent);
			}
	    });
	    
	    
	    
	    Button history = (Button)this.findViewById(R.id.history);
	    history.setOnClickListener(new OnClickListener() {
	    	@Override
			public void onClick(View arg0) {		
	    		Intent intent=new Intent(Introduction.this,History.class);
				startActivity(intent);
			}
	    });
	    
	    
	    
	    Button song = (Button)this.findViewById(R.id.song);
	    song.setOnClickListener(new OnClickListener() {
	    	@Override
			public void onClick(View arg0) {		
	    		Intent intent=new Intent(Introduction.this,Song.class);
				startActivity(intent);
			}
	    });
	
	
	}
}
