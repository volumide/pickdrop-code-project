import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { AuthserviceService, data } from '../authservice.service';

@Component({
  selector: 'app-signin',
  templateUrl: './signin.component.html',
  styleUrls: ['./signin.component.css']
})
export class SigninComponent implements OnInit {

  public data : data = {
    'id': '',
    'email': '',
    'password' : '',
    'name': ''
  }  

  public errors ={
    "emailerror": "",
    "passworderror": "",
  }

  public load: boolean = false;
  public success:boolean = true
  constructor(public router:Router, public service: AuthserviceService) { }

  
  signin(id:any){
    this.load = true
    this.service.signIn(this.data).
    subscribe(responds =>{
      console.clear()
      console.log(responds)
      let result = responds['data']['content']
      localStorage.setItem('pickdroptoken', responds['data']['token'])
      localStorage.setItem('pickdropid', result['id'])
      console.log(result)
      this.data.email = ''
      this.data.password = ''
      this.data.name = result['name']
      id = result.id
      localStorage.setItem('pickdropstatus', result.status)
      switch (result.status) {
        case 'rider':
          this.router.navigate(['/myrequest'], {replaceUrl:true})
          break;
      
        default:
          this.router.navigate(['/request-form'], {replaceUrl:true})
          break;
      }

     
      this.load= false
    }, err => {
      console.clear()
      this.success = false
      setTimeout(() => {
        this.success = true
      }, 2000);
      console.log(err['error'].error)
      this.load = false
      // let errors = err['error']['errors']
      // this.errors.emailerror = errors.email
      // this.errors.passworderror = errors.password
      // console.log(errors)
    })
    // console.log(this.data)
  }


  ngOnInit() {
  }


}
