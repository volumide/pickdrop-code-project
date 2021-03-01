import { Component, OnInit , ViewChild, ElementRef } from '@angular/core';


@Component({
  selector: 'app-map',
  templateUrl: './map.component.html',
  styleUrls: ['./map.component.css']
})
export class MapComponent implements OnInit {
  @ViewChild('mapContainer', {static: false}) gmap: ElementRef;
  public map: google.maps.Map
  public lat: any
  public lng: any
  public coordinates : any
  public directionservice : google.maps.DirectionsService
  public directiondisplay : google.maps.DirectionsRenderer
  public mapOptions: google.maps.MapOptions = {
    center: this.coordinates,
    zoom: 15,
    mapTypeControl: false,
    fullscreenControl: false,
  };
  constructor() { }

  // getlatlng(){
  //   let geo 
  //   if (navigator.geolocation) {
  //     navigator.geolocation.getCurrentPosition(data => {
  //     })
  //   }
  //   return geo
  // }
 
  getlocation(){
    if(navigator.geolocation){
      navigator.geolocation.getCurrentPosition(data =>{
        let marker = new google.maps.InfoWindow
        this.lat = data.coords.latitude
        this.lng = data.coords.longitude
        this.coordinates = new google.maps.LatLng(this.lat,this.lng)
        this.mapOptions.center = this.coordinates

        let markers = new google.maps.Marker({
          position: this.coordinates,
          title: 'hello',
          map: this.map,
        })
        // markers.getLabel
        // markers.getIcon()        
       

        this.map = new google.maps.Map(this.gmap.nativeElement, this.mapOptions)

        marker.setPosition(this.mapOptions.center)
        markers.setIcon('https://developers.google.com/maps/documentation/javascript/examples/full/images/info-i_maps.png')
        
        // marker.setContent("hello are you working")
        marker.open(this.map)
        this.map.setCenter(this.mapOptions.center)
      }, err => console.log(err))
    }
  }
 

  // ngOnInit() {
  //   let k = {"hello": this.getlatlng()}
  //   console.log(k)
  // }

  getdirection(origins:string ='', directions:string=''){
    // this.getlatlng()
    this.mapOptions.mapTypeControl =false
    this.map = new google.maps.Map(document.getElementById('map'), {
      zoom: 15,
      center: {
        lat:6.6419854, 
        lng: 3.3467777
      },
      mapTypeControl: false
    });
    console.log(this.lat, this.lng)
    let direction = new google.maps.DirectionsRenderer
    let service = new google.maps.DirectionsService
  
    service.route({
      origin: origins,
      destination: directions,
      travelMode: google.maps.TravelMode.DRIVING
      
    }, (res:google.maps.DirectionsResult, status: google.maps.DirectionsStatus)=>{
        if (status === "OK") {
          direction.setDirections(res)
        }
    })
    direction.setMap(this.map)
  }

  getlatlng(){
    let all :any[] = new Array
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(res =>{
        this.lat = res.coords.latitude
        this.lng = res.coords.longitude
        all.push(this.lat, this.lng)
      })
    }
    // console.log(all)
  }

  ngAfterViewInit() {
    this.getlocation()
   
  }
  ngOnInit(){
    this.getlatlng()
  }

}
