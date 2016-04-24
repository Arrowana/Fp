package com.example.arowana.shortstories;

public class Ssoverview {
    private String id;
    private String ttl;
	private String ath;
	private String note;

	public Ssoverview(String id, String title, String author, String note){
        this.id=id;
		this.ttl=title;
		this.ath=author;
		this.note=note;
	}

    public String getId(){
        return this.id;
    }

	public String getTitle(){
        return this.ttl;
	}
	
	public String getAuthor(){
		return this.ath;
	}

	public String getNote() {
		return this.note;
	}
}
