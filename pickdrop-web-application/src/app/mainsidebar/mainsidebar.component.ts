import { Component, OnInit, Input } from
 '@angular/core';
import { Router } from '@angular/router';
import { AuthserviceService } from '../authservice.service';


@Component({
  selector: 'app-mainsidebar',
  templateUrl: './mainsidebar.component.html',
  styleUrls: ['./mainsidebar.component.css']
})
export class MainsidebarComponent implements OnInit {
  @Input('log') log:any;
  @Input('name') name:string;

  public id = localStorage.getItem('pickdropid')
  public token = localStorage.getItem('pickdroptoken')
  constructor(public router: Router, public service: AuthserviceService) { }

  ngOnInit() {
    this.getuser()
  }


  logout(){
    localStorage.removeItem('pickdroptoken')
    localStorage.removeItem('pickdropid')
    this.router.navigate(['/signin'], {replaceUrl: true})
  }

  getuser(){
    if (!this.id) {
      this.router.navigate(['/signin'])
      return
    }
    this.service.myprofile(this.token).subscribe(res =>{
      let profile = res['data']
      this.name = profile.name
     
      if (profile.status == 'rider') {
        this.log = true
      }else{
        this.log = false
      }
    }, err =>{
      console.log(err)
    })
  }
}
