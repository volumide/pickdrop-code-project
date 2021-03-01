import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-payment',
  templateUrl: './payment.component.html',
  styleUrls: ['./payment.component.css']
})
export class PaymentComponent implements OnInit {

  constructor(public router: Router) { }

  ngOnInit() {
    let token = localStorage.getItem('pickdroptoken')
    if (!token) {
      this.router.navigate(['/signin'])
    }
  }

}
