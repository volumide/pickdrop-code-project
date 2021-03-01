import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-trackdelivery',
  templateUrl: './trackdelivery.component.html',
  styleUrls: ['./trackdelivery.component.css']
})
export class TrackdeliveryComponent implements OnInit {

 
  constructor(public router: Router) { }

  ngOnInit() {
    let token = localStorage.getItem('pickdroptoken')
    if (!token) {
      this.router.navigate(['/signin'])
    }
  }

}
