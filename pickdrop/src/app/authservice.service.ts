import { Injectable } from '@angular/core';
// import { Router, } from '@angular/router';
import { HttpClient, HttpHeaders } from '@angular/common/http';

export interface data{
  "id"?: any,
  "name"?: string,
  "email": string,
  "password": string,
  "status"?: string,
  "phone"?: string
}

@Injectable({
  providedIn: 'root'
})

export class AuthserviceService {

  public url:string = 'http://pickdrop.us-east-2.elasticbeanstalk.com/api/v1/'
  constructor( public http: HttpClient) { }

  public headers(token:string = ''){
    let header = {
      headers: new HttpHeaders({
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${token}`
      })   
    }
    return header
  }

  customerSignup(data:any){
    return this.http.post(`${this.url}signup`, data)
  }

  RiderSignup(data:any){
    return this.http.post(`${this.url}signup`, data)
  }

  signIn(data:any){
    return this.http.post(`${this.url}signin`, data)
  }

  myprofile(token:string){
    return this.http.get(`${this.url}my-profile`, this.headers(token))
  }

  getallUsers(token:string){
    return this.http.get(`${this.url}allusers`, this.headers(token))
  }

  getallUser(token:string, id:any){
    return this.http.get(`${this.url}userprofile/${id}`, this.headers(token))
  }

  // updateProfile(token:string, id:any, data){
  //   return this.http.post(`${this.url}userprofile/${id}`, data, this.headers(token))
  // }

  updatemyProfile(token:string,  data){
    return this.http.put(`${this.url}userupdate`, data, this.headers(token))
  }



  gettoken(token){
    if(token){
      return true
    }
    return false
  }

  findrider(token:string, data){
    return this.http.post(`${this.url}findrider`,data, this.headers(token))
  }

  bookrider(token:string, data){
    return this.http.post(`${this.url}makerequest`, data, this.headers(token))
  }

  pendingRequests(token:string){
    return this.http.get(`${this.url}riderlogs`, this.headers(token))
  }
  
  myRequests(token:string){
    return this.http.get(`${this.url}riderlogs`, this.headers(token))
  }
  
  updateRidestatus(token:string, id:any){
    return this.http.put(`${this.url}updatedeliverystatus/${id}`, '', this.headers(token))
  }

  rejectRide(token:string, id:any){
    return this.http.put(`${this.url}reject/ride/${id}`, '', this.headers(token))
  }

  myrequests(token:string){
    return this.http.get(`${this.url}user/request/log`, this.headers(token))
  }

  confirmCode(token:string, id:any, code:any){
    return this.http.get(`${this.url}confirm/pin/${id}/${code}`, this.headers(token))
  }

  uploadPic(token:string, img){
    return this.http.put(`${this.url}upload`,img, this.headers(token))
  }
}


