import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { AuthserviceService, data } from '../authservice.service';


@Component({
  selector: 'app-ridersignup',
  templateUrl: './ridersignup.component.html',
  styleUrls: ['./ridersignup.component.css']
})
export class RidersignupComponent implements OnInit {

  public data: data = {
    "name": "",
    "email":"",
    "password": "",
    "status": "rider",
    "phone": ""
  }
  
  public errors ={
    "emailerror": "",
    "passworderror": "",
    "phoneerror": "",
    "nameerror": ""
  }
  public load:boolean = false
  public success:boolean = false;
  constructor(public router:Router, public service: AuthserviceService) { }

  signup(){
    this.load = true

    if (this.data.name == '') {
      this.errors.nameerror = 'invalid name format'
      this.load = false
      return
    }else{
      this.errors.nameerror = ''
    }

    if (this.data.email == '') {
      this.errors.emailerror = 'Invalid email'
      this.load = false
      return
    }else{
      this.errors.emailerror = ''
    }

    if (this.data.password == '') {
      this.errors.passworderror = 'invalid password'
      this.load = false
      return
    }else{
      this.errors.passworderror = ''
    }


    this.service.customerSignup(this.data).
    subscribe(responds =>{
      console.clear()
      console.log(responds)
      this.data.email = ''
      this.data.name = ''
      this.data.password = ''
      this.data.phone = ''
      this.success = true
      // this.router.navigate(['/signin'], {replaceUrl: true})
      this.load = false
    }, err => {
      console.clear()
      let errors = err
      console.log(errors['message'])
      this.load = false
      this.success = false
    })
    // console.log(this.data)
  }

  ngOnInit() {
  }
}
