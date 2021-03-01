import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { AuthserviceService } from '../authservice.service';
import { trigger, state, style, transition, animate } from '@angular/animations';


@Component({
  selector: 'app-profile',
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.css'],
  animations: [
    trigger('showandhide', [
      state('show', style({
        transform: 'translateX(300px)'
      })),
      state('hide', style({
        transform: 'translateX(0)'
      })),
      transition('show => hide', [
        animate('0.5s')
      ]),
      transition('hide => show', [
        animate('0.3s')
      ])
    ])
  ]
})
export class ProfileComponent implements OnInit {
public token = localStorage.getItem('pickdroptoken')
public id = localStorage.getItem('pickdropid')
  constructor(public router: ActivatedRoute, public service: AuthserviceService, public routers: Router) { }
  public sure = true
  public name  : string
  public phone : string
  public email : string
  public log : boolean;
  public image: any
  public loading = false
  public data = {
    "picture": ""
  }
  public picture
  ngOnInit() {
    if (!this.token) {
      this.routers.navigate(['/signin'])
    }
    this.myprofile()
  }

  trigger(){
    this.sure = !this.sure
  }

  upload(event:any){
    if (!event) {
      return
    }
    if (event.target.files[0] && event.target.files) {
      let file = new FileReader()
      file.onload = (e: any) => {
        this.image = e.target.result
        // this.data.picture = this.image
      }
      file.readAsDataURL(event.target.files[0])
    }
    // let file = event.target.files[0]
    
    //   let reader = new FileReader()
    //   reader.readAsDataURL(file);der.onload = (data)=>{
    //     this.image = data.target.result
    //     // console.log(data)
    //     console.log(this.image)
    //   }
  
  }

  uploadPic(){
    this.loading = true
    if (!this.image) {
      alert('no image to upload')
      this.loading = !this.loading
      return
    }
    // console.log(this.image)
    this.data.picture = this.image
    this.service.uploadPic(this.token, this.data).subscribe(res => {
      console.log(res)
      this.loading = false
    }, err => {
      console.log(err)
      this.loading = false
    })
  }

  myprofile(){
    if (!this.id) {
      this.routers.navigate(['/signin'])
      return
    }
    this.service.myprofile(this.token).subscribe(res =>{
      console.log(res)
      let myprofile = res['data']
      this.name = myprofile.name
      this.phone = myprofile.phone,
      this.email = myprofile.email
      this.picture = myprofile.picture
      let status = myprofile.status
      switch (status) {
        case 'rider':
          this.log = true
          break;
        case 'customer':
          this.log = false
          break;
        default:
          break;
      }
    }, err =>{
      console.log(err)
    })
  }
}
