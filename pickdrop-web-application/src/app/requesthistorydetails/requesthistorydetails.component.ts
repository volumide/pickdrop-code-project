import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { AuthserviceService } from '../authservice.service';


@Component({
  selector: 'app-requesthistorydetails',
  templateUrl: './requesthistorydetails.component.html',
  styleUrls: ['./requesthistorydetails.component.css']
})
export class RequesthistorydetailsComponent implements OnInit {

  public token = localStorage.getItem('pickdroptoken')
  constructor(public router: Router, public service: AuthserviceService) { }
  public allrequest: any[]
  public data ={
    time: "",
    status: "",
    code: "",
    name: ""
  }
  public detail:boolean = false
  ngOnInit() {
    
    if (!this.token) {
      this.router.navigate(['/signin'])
    }
    this.myRequests()
  }

  myRequests(){
    this.service.myrequests(this.token).subscribe(res => {
      console.log(res)
      this.allrequest = res['data']
    }, err =>{
        console.log(err)
      })
  }

  details(data){
    // console.log(data)
    this.data.name = data.rider_name
    this.data.status = data.status
    this.data.time = data.pick_up_time
    this.data.code = data.request_code
    this.detail = true
  }
}
