import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-comming-soon',
  templateUrl: './comming-soon.component.html',
  styleUrls: ['./comming-soon.component.css']
})
export class CommingSoonComponent implements OnInit {
  
  public days
  public hours
  public mins
  public secs

  constructor() { }

  ngOnInit() {
    this.days = 23  
    this.hours = 23 
    this.mins = 23  
    this.secs = 23 
  }
}
