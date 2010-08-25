package com.account.test;

import java.util.Vector;

public class LoginTest {
	public static void main(String argv[]){
		getGrilleToLogin();
	}
	
	public static int[] getGrilleToLogin(){
		Vector<Integer> keys = new Vector<Integer>();
		Vector<Integer> items = new Vector<Integer>();
		
		for(int j = 0;j < 10; j++){
			keys.add(j);
		}
		
		for(int j = 0;j < 25; j++){
			items.add(j);
		}
		
		int tableau [] = new int[25];
		for (int i = 0; i < tableau.length; i++) {
			tableau[i] = 0;
		}
		
		for(int i = 0; i < 10; i++){
			int randomK = (int)(Math.random() * (keys.size()-0)) + 0;
			int itemK = (Integer)keys.get(randomK).intValue();
			keys.remove(randomK);
			int randomI = (int)(Math.random() * (items.size()-0)) + 0;
			int itemI = (Integer)items.get(randomI).intValue();
			items.remove(randomI);
			tableau[itemI]=itemK;
			//System.out.println(randomK+" "+randomI);
		}
		for (int i = 0; i < 25; i++) {
			System.out.print(tableau[i]+" ");
		}
		return tableau;
	}
}
