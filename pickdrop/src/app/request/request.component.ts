import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-request',
  templateUrl: './request.component.html',
  styleUrls: ['./request.component.css']
})
export class RequestComponent implements OnInit {

  
  constructor(public router: Router) { }

  ngOnInit() {
    let token = localStorage.getItem('pickdroptoken')
    if (!token) {
      this.router.navigate(['/signin'])
    }
  }
}
