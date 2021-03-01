import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { MapComponent } from '../map/map.component';
import { AuthserviceService } from '../authservice.service';

@Component({
  selector: 'app-riderlog',
  templateUrl: './riderlog.component.html',
  styleUrls: ['./riderlog.component.css'],
  providers:[ MapComponent]
})

export class RiderlogComponent implements OnInit {
  public name: string 
  public allrequest: any[]
  public token:string = localStorage.getItem('pickdroptoken')
  public code: any
  public index: any
  public success = false
  public wrong = false
  public load = 0
  public loading = false
  constructor(public router: Router,private service: AuthserviceService, public direction: MapComponent) { }

  ngOnInit() {
    if (!this.token) {
      this.router.navigate(['/signin'])
    }
    this.getCustomerRequest()
  }

  getCustomerRequest(){
    this.service.pendingRequests(this.token).subscribe(responds => {
      // console.log(responds['data'])
      this.allrequest = responds['data']
      this.load = 0
      this.loading = false
    },err => {
      console.log(err)
    })
  }

  updateride(id:any){ 
    this.load = id
    this.loading = true
    this.service.updateRidestatus(this.token,id).subscribe(respond=>{
      console.log(respond)
      this.getCustomerRequest()
    } , err=>console.log(err))
  }
  getid(id:any){
    this.code = ''
    this.index = id
    this.success = false
  }

  checkcode(){
    // console.log(this.index)
    this.loading = true
    if (this.code) {
      this.service.confirmCode(this.token, this.index, this.code ).subscribe(res=> {
        if (res['data']) {
          this.success = !this.success
          this.updateride(this.index)
        }else{
          this.wrong = !this.wrong
          setTimeout(() => {
            this.wrong = !this.wrong
          }, 2000);
          console.log(res['message'])
        }
        this.loading = false
      }, err=>console.log(err))
    }
  }
  rejectRide(id:any){
    this.loading = true
    this.load = id
    this.service.rejectRide(this.token, id).subscribe( () =>{
      this.getCustomerRequest()
      // this.load = !this.load
    }, err =>{
      console.log(err)
      this.load = 0
    })
  }
  getdirection(){
    this.direction.getdirection()
  }
}
