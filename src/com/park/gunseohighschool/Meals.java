package com.park.gunseohighschool;

import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.ObjectInputStream;
import java.io.ObjectOutputStream;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.List;

import net.htmlparser.jericho.Element;
import net.htmlparser.jericho.HTMLElementName;
import net.htmlparser.jericho.Source;
import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.net.ConnectivityManager;
import android.net.NetworkInfo.State;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.Window;
import android.widget.TextView;
import android.widget.Toast;

public class Meals extends Activity {

	final String URL = "http://hes.goe.go.kr/sts_sci_md00_001.do?schulCode=J100004910&insttNm=%EA%B5%B0%EC%84%9C%EA%B3%A0%EB%93%B1%ED%95%99%EA%B5%90&schulCrseScCode=4&schulKndScCode=04&schYm=2014.";
	int month, date, iday;
	Source source;
	Calendar cal;
	ArrayList<String> mealArr;
	TextView mealTV, dateTV;
	Toast toast;
	String day;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		requestWindowFeature(Window.FEATURE_NO_TITLE);
		setContentView(R.layout.activity_meals);

		
		
		cal = Calendar.getInstance();
		dateTV = (TextView) findViewById(R.id.day);
		mealTV = (TextView) findViewById(R.id.meal);
		mealArr = new ArrayList<String>();
		findViewById(R.id.back).setOnClickListener(listener);
		findViewById(R.id.today).setOnClickListener(listener);
		findViewById(R.id.next).setOnClickListener(listener);

		initialize();
	}

	private void initialize() {
		source = null;
		mealArr.clear();
		month = cal.get(Calendar.MONTH) + 1;
		date = cal.get(Calendar.DATE);
		iday = cal.get(Calendar.DAY_OF_WEEK);
		switch (cal.get(Calendar.DAY_OF_WEEK)) {
		case 1:
			day = "일요일";
			break;
		case 2:
			day = "월요일";
			break;
		case 3:
			day = "화요일";
			break;
		case 4:
			day = "수요일";
			break;
		case 5:
			day = "목요일";
			break;
		case 6:
			day = "금요일";
			break;
		case 7:
			day = "토요일";
			break;
		}
		try {
			getDataFromFile();
		} catch (FileNotFoundException e) {
			if (isNetworkAvailable()) {
				getDataFromServer();
			}
		} finally {
			setText();
		}
	}

	private void setText() {
		if (mealArr.isEmpty()) {
			dateTV.setText("");
			mealTV.setText("");
			if (toast == null) {
				toast = Toast.makeText(this, "네트워크 상태를 확인하세요.",
						Toast.LENGTH_SHORT);
			}
			toast.show();
			return;
		}
		month = cal.get(Calendar.MONTH) + 1;
		date = cal.get(Calendar.DATE);
		dateTV.setText(month + "월 " + date + "일 " + day);
		mealTV.setText(mealArr.get(date - 1));
	}

	View.OnClickListener listener = new View.OnClickListener() {
		@Override
		public void onClick(View v) {
			switch (v.getId()) {
			case R.id.back:
				cal.set(Calendar.DATE, date - 1);
				if (iday != cal.get(Calendar.DAY_OF_WEEK)) {
					initialize();
				} else {
					setText();
				}
				break;
			case R.id.today:
				cal = Calendar.getInstance();
				if (iday != cal.get(Calendar.DAY_OF_WEEK)) {
					initialize();
				} else {
					setText();
				}
				break;
			case R.id.next:
				cal.set(Calendar.DATE, date + 1);
				if (iday != cal.get(Calendar.DAY_OF_WEEK)) {
					initialize();
				} else {
					setText();
				}
				break;
			}
		}
	};

	private boolean isNetworkAvailable() {
		ConnectivityManager connect = (ConnectivityManager) getSystemService(Context.CONNECTIVITY_SERVICE);
		if (connect.getNetworkInfo(ConnectivityManager.TYPE_MOBILE).getState() == State.CONNECTED
				|| connect.getNetworkInfo(ConnectivityManager.TYPE_WIFI)
						.getState() == State.CONNECTED) {
			return true;
		} else {
			return false;
		}
	}

	@SuppressWarnings("unchecked")
	private void getDataFromFile() throws FileNotFoundException {
		try {
			FileInputStream fis = this.openFileInput(cal.get(Calendar.YEAR)
					+ "." + month);
			ObjectInputStream ois = new ObjectInputStream(fis);
			ArrayList<String> t = (ArrayList<String>) ois.readObject();
			mealArr = (ArrayList<String>) t.clone();
			ois.close();
		} catch (FileNotFoundException e) {
			throw e;
		} catch (IOException e) {
			e.printStackTrace();
		} catch (ClassNotFoundException e) {
			e.printStackTrace();
		}
	}

	private void getDataFromServer() {
		Thread thread = new Thread() {
			@Override
			public void run() {
				try {
					String urlMonth;
					if (month < 10) {
						urlMonth = "0" + month;
					} else {
						urlMonth = "" + month;
					}
					source = new Source(new InputStreamReader(new URL(URL
							+ urlMonth).openStream(), "UTF-8"));
				} catch (MalformedURLException e) {
					e.printStackTrace();
				} catch (IOException e) {
					e.printStackTrace();
				}
			}
		};
		thread.start();
		try {
			thread.join();
		} catch (InterruptedException e) {
			e.printStackTrace();
		}
		List<Element> td = source.getAllElements(HTMLElementName.TABLE).get(0)
				.getAllElements(HTMLElementName.TD);

		for (Element element : td) {
			String content = element.getContent().toString();
			content = content.replaceAll("<div>", "").replaceAll("</div>", "")
					.replaceAll("<br />", "\n").replace("[석식]", "\n[석식]")
					.trim();
			if (!content.isEmpty()) {
				int index;
				if ((index = content.indexOf("[")) == -1) {
					content = "급식이 없습니다.";
				} else {
					content = content.substring(index);
				}
				mealArr.add(content);
			}

		}
		try {
			FileOutputStream fos = openFileOutput(cal.get(Calendar.YEAR) + "."
					+ month, Context.MODE_PRIVATE);
			ObjectOutputStream oos = new ObjectOutputStream(fos);
			oos.writeObject(mealArr);
			oos.close();
		} catch (IOException e) {
			e.printStackTrace();
		}
	}

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		getMenuInflater().inflate(R.menu.meals, menu);
		return true;
	}

	@Override
	   public boolean onOptionsItemSelected(MenuItem item) {      
	      int id = item.getItemId();
	      if (id == R.id.refresh) {
	         if(isNetworkAvailable()) {
	            deleteFile(cal.get(Calendar.YEAR)+"."+month);
	            initialize();
	         } else {
	            Toast.makeText(this,"네트워크 상태를 확인하세요.",Toast.LENGTH_SHORT).show();
	         }
	         
	         return true;
	      }
	      return super.onOptionsItemSelected(item);
	   }
}