import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-requestdelivery',
  templateUrl: './requestdelivery.component.html',
  styleUrls: ['./requestdelivery.component.css']
})
export class RequestdeliveryComponent implements OnInit {

  public origin: string
  constructor(public router: Router) { }

  ngOnInit() {
    let token = localStorage.getItem('pickdroptoken')
    if (!token) {
      this.router.navigate(['/signin'])
    }
  }



}
