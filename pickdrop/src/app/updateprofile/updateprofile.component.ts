import { Component, OnInit } from '@angular/core';
import { AuthserviceService } from '../authservice.service';

@Component({
  selector: 'app-updateprofile',
  templateUrl: './updateprofile.component.html',
  styleUrls: ['./updateprofile.component.css']
})
export class UpdateprofileComponent implements OnInit {
  token = localStorage.getItem('pickdroptoken')
  constructor(private service: AuthserviceService) { }
  public data ={
    "name": "",
    "region": "",
    "country": "",
    "phone": "",
  }
  public load  = false
  public email
  ngOnInit() {
    this.getprofile()
  }

  updateProfile(){
    // console.log(this.data)
    this.load = true
    this.service.updatemyProfile(this.token, this.data).subscribe(res => {
      this.load = false
      console.log(res)
    }, err => {
      this.load = false
      console.log(err)
    })
  }

  getprofile(){
    this.service.myprofile(this.token).subscribe(res =>{
      console.log(res['data'])
      let profile = res['data']
      this.data.name = profile.name
      this.email = profile.email
      this.data.phone = profile.phone
      this.data.region = profile.region
      this.data.country = profile.country
    }, err => console.log(err))
  }
}
