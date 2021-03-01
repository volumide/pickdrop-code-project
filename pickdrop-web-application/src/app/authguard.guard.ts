import { Injectable } from '@angular/core';
import { CanActivate, Router,  } from '@angular/router';
// import { Observable } from 'rxjs';
import { AuthserviceService } from './authservice.service';

@Injectable({
  providedIn: 'root'
})
export class AuthguardGuard implements CanActivate {
  public token = localStorage.getItem('pickdroptoken')
  constructor(public serveice: AuthserviceService, public route: Router){}
  canActivate(): boolean{
      let userexist = this.serveice.gettoken(this.token)
      if(!userexist){
        this.route.navigate(['signin'])
        return false
      }

      return true
    }
  
}
