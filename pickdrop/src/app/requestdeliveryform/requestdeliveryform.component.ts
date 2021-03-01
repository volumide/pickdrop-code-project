import { Component, OnInit, ViewChild} from '@angular/core';
import { Router } from '@angular/router';
import { MapComponent } from '../map/map.component';
import { GooglePlaceDirective } from 'ngx-google-places-autocomplete';
import { Address } from 'ngx-google-places-autocomplete/objects/address';
import { AuthserviceService } from '../authservice.service';

@Component({
  selector: 'app-requestdeliveryform',
  templateUrl: './requestdeliveryform.component.html',
  styleUrls: ['./requestdeliveryform.component.css'],
  providers: [MapComponent],
})
export class RequestdeliveryformComponent implements OnInit {

  @ViewChild("placesRef", {static: false}) placesRef : GooglePlaceDirective;

  public responds:boolean = false
  public pickup: string
  public dropup: string
  public token = localStorage.getItem('pickdroptoken')

  public data = {
    "pick_up_location":"",
    "drop_up_location" :"",
    "pick_up_date": "",
    "pick_up_time": "",
    "pick_up_instruction": "",
    "vehicle": "",
    "length": "",
    "width": "",
    "height": "",
    "weight": "",
    "user_uuid":"",
    "rider_uuid": "",
    "price": ""
  }
  
  public secdata ={
    "pick_up_location":"",
    "drop_up_location" :"",
    "vehicle_type":"",
  }

  
  public message : string = ''
  public requestcomplete : boolean = false
  public ridername : string
  public riderphone : string
  public cost : string
  public lat : any
  public lng : any
  public loading: boolean = false
  public success: boolean = false
  public status: string

  constructor(public router: Router, public map: MapComponent, public service: AuthserviceService) { }

  ngOnInit() {
    this.getprofile()
    let status = localStorage.getItem('pickdropstatus')
    if (!this.token) {
      this.router.navigate(['/signin'])
      return
    }
    switch (status) {
      case 'rider':
        this.router.navigate(['/myrequest'])
        break;
      default:
        break;
    }
  }

  getprofile(){
    this.service.myprofile(this.token).subscribe(data=>{
      this.data.user_uuid = data['data'].uuid
      // console.log(data)
    }, err =>{
      console.log(err)
    })
  }
  
  getdirection(){
    // console.clear()
    if (this.pickup ==='' || this.dropup === '') {
      this.map.getlocation()
    } else {
      let origin = this.pickup
      let destination = this.dropup
      this.map.getdirection(origin, destination)
    }
  }

  changed(event){
    this.secdata.vehicle_type = event.target.value
    this.data.vehicle = event.target.value
    // console.log(event.target.value)
  }

  getrider(){
    this.requestcomplete = false
    this.data.pick_up_location = this.pickup
    this.data.drop_up_location = this.dropup

    this.secdata.pick_up_location = this.pickup
    this.secdata.drop_up_location = this.dropup
  
    console.log(this.secdata)
    this.service.findrider(this.token, this.secdata).subscribe((responds)=>{
        this.getdirection()
        this.requestcomplete = true
        let riderinfo = responds['rider_detail']
        if (!riderinfo) {
          this.message = 'No driver found in your region'
          return
        }
        this.responds = true
        this.ridername = riderinfo.name
        this.riderphone = riderinfo.phone
        this.data.rider_uuid = riderinfo.uuid
        switch (this.secdata.vehicle_type) {
          case 'car':
            this.cost = responds['car'].total_cost
            this.data.price = this.cost
            break
          case 'truck':
            this.cost = responds['truck'].total_cost
            this.data.price = this.cost
            break
          default:
            break
        }
        this.requestcomplete = true
    }, (err)=>{
          // this.message = err['message']
          this.responds = false
          console.log(err.message)
    })
  }

  sendrequest(){
    this.loading = !this.loading
    this.service.bookrider(this.token, this.data).subscribe(res => {
      console.log(res)
      this.success =!this.success
      this.loading = !this.loading
      this.status = 'Request sent'
    }, err =>{
      console.log(err)
    })
  }

  handleAddressChange(address: Address){
      address.formatted_address
  }

}
