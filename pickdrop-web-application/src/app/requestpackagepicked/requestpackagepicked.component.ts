import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-requestpackagepicked',
  templateUrl: './requestpackagepicked.component.html',
  styleUrls: ['./requestpackagepicked.component.css']
})
export class RequestpackagepickedComponent implements OnInit {

  constructor(public router: Router) { }

  ngOnInit() {
    let token = localStorage.getItem('pickdroptoken')
    if (!token) {
      this.router.navigate(['/signin'])
    }
  }
}
