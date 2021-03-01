import { Component} from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  title = 'pickdrop';
  token = localStorage.getItem('pickdroptoken')
  constructor( public router: Router){
    if (!this.token) {
      this.router.navigate(['/signin'])
    }
  }

  ngOnInit(){
    
  }
}
