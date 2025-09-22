package com.park.gunseohighschool;

import android.app.Activity;
import android.app.AlertDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.net.Uri;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.Window;
import android.widget.ImageButton;

public class Main extends Activity {

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		requestWindowFeature(Window.FEATURE_NO_TITLE);
		setContentView(R.layout.activity_main);

		ImageButton Button1 = (ImageButton) this.findViewById(R.id.meal);
		Button1.setOnClickListener(new OnClickListener() {
			@Override
			public void onClick(View arg0) {
				Intent intent = new Intent(Main.this, Meals.class);
				startActivity(intent);
			}
		}); // 급식

		ImageButton Button2 = (ImageButton) findViewById(R.id.schedule);
		Button2.setOnClickListener(new OnClickListener() {
			public void onClick(View v) {
				Intent myIntent = new Intent(Main.this, Schedule.class);
				startActivity(myIntent);
			}
		}); // 학교일정

		ImageButton Button3 = (ImageButton) findViewById(R.id.timetable);
		Button3.setOnClickListener(new OnClickListener() {
			public void onClick(View v) {
				Intent myIntent = new Intent(Main.this, Timetable.class);
				startActivity(myIntent);
			}
		}); // 시간표

		ImageButton Button4 = (ImageButton) findViewById(R.id.facebook);
		Button4.setOnClickListener(new OnClickListener() {
			public void onClick(View v) {
				Intent myIntent = new Intent(Main.this, Facebook.class);
				startActivity(myIntent);
			}
		}); // 페이스북 주소

		ImageButton Button5 = (ImageButton) findViewById(R.id.web);
		Button5.setOnClickListener(new OnClickListener() {
			public void onClick(View v) {
				Intent myIntent = new Intent(Main.this, GunWeb.class);
				startActivity(myIntent);
			}
		}); // 학교홈페이지

		ImageButton Button6 = (ImageButton) findViewById(R.id.developer);
		Button6.setOnClickListener(new OnClickListener() {
			public void onClick(View v) {
				Intent myIntent = new Intent(Main.this, Developer.class);
				startActivity(myIntent);
			}
		}); // 개발자정보

		ImageButton Button8 = (ImageButton) findViewById(R.id.intro);
		Button8.setOnClickListener(new OnClickListener() {
			public void onClick(View v) {
				Intent myIntent = new Intent(Main.this, Introduction.class);
				startActivity(myIntent);
			}
		}); // 학교소개

		ImageButton notice = (ImageButton) findViewById(R.id.notice);
		notice.setOnClickListener(new OnClickListener() {
			public void onClick(View v) {
				Intent myIntent = new Intent(Main.this, Notice.class);
				startActivity(myIntent);
			}
		}); // 공지사항

		ImageButton library = (ImageButton) findViewById(R.id.library);
		library.setOnClickListener(new OnClickListener() {
			public void onClick(View v) {
				Intent myIntent = new Intent(Main.this, Library.class);
				startActivity(myIntent);
			}
		}); // 도서실정

		ImageButton call = (ImageButton) findViewById(R.id.call);
		call.setOnClickListener(new View.OnClickListener() {
			@Override
			public void onClick(View v) {
				final AlertDialog.Builder menuAleart = new AlertDialog.Builder(
						Main.this);
				final String[] menuList = { "교무실", "행정실" };
				menuAleart.setTitle("군서고등학교");
				menuAleart.setItems(menuList,
						new DialogInterface.OnClickListener() {
							@Override
							public void onClick(DialogInterface dialog, int item) {
								switch (item) {

								case 0:
									Intent intent;
									intent = new Intent(Intent.ACTION_DIAL, Uri
											.parse("tel:031-363-1525"));
									startActivity(intent);
									break;
								case 1:
									intent = new Intent(Intent.ACTION_DIAL, Uri
											.parse("tel:031-363-1510"));
									startActivity(intent);
									break;
								}
							}
						});

				AlertDialog menuDrop = menuAleart.create();
				menuDrop.show();
			}
		}); // 학교 전화

	}
}
