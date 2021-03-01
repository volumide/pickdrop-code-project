import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-landing',
  templateUrl: './landing.component.html',
  styleUrls: ['./landing.component.css']
})
export class LandingComponent implements OnInit {
  token = localStorage.getItem('pickdroptoken')
  constructor(private router: Router) { }

  ngOnInit() {
    if (this.token) {
      this.router.navigate(['/request-form'])
    }
  }

}
