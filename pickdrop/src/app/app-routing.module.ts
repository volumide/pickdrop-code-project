import { NgModule } from '@angular/core';
import { PreloadAllModules, Routes, RouterModule } from '@angular/router';
import { LandingComponent } from './landing/landing.component';
import { AuthsidebarComponent } from './authsidebar/authsidebar.component';
import { RidersignupComponent } from './ridersignup/ridersignup.component';
import { CutomersignupComponent } from './cutomersignup/cutomersignup.component';
import { SigninComponent } from './signin/signin.component';
import { MainsidebarComponent } from './mainsidebar/mainsidebar.component';
import { ProfileComponent } from './profile/profile.component';
import { RequestComponent } from './request/request.component';
import { RequestdeliveryComponent } from './requestdelivery/requestdelivery.component';
import { PaymentComponent } from './payment/payment.component';
import { NavigationComponent } from './navigation/navigation.component';
import { AddcardComponent } from './addcard/addcard.component';
import { RequestdeliveryformComponent } from './requestdeliveryform/requestdeliveryform.component';
import { RequestpackagepickedComponent } from './requestpackagepicked/requestpackagepicked.component';
import { MapComponent } from './map/map.component';
import { TrackdeliveryComponent } from './trackdelivery/trackdelivery.component';
import { RequesthistorydetailsComponent } from './requesthistorydetails/requesthistorydetails.component';

import { RiderlogComponent } from './riderlog/riderlog.component';
import { ForgetpasswordComponent } from './forgetpassword/forgetpassword.component';
import { AuthguardGuard } from './authguard.guard';
import { UpdateprofileComponent } from './updateprofile/updateprofile.component';




const routes: Routes = [
  {
    path: '',
    redirectTo: 'landing',
    pathMatch: 'full'
  },
  {
    path: 'landing', 
    component: LandingComponent
  },

  {
    path:'forget-password',
    component: ForgetpasswordComponent
  },
  {
    path: 'authsidebar', 
    component: AuthsidebarComponent
  },

  {
    path:'ridersignup', 
    component: RidersignupComponent
  },

  {
    path:'customersignup', 
    component: CutomersignupComponent
  },

  {
    path: 'signin', 
    component: SigninComponent 
  },

  {
    path: 'mainsidebar', 
    component:MainsidebarComponent
  },

  {
    path:'profile/:name', 
    component:ProfileComponent ,
    canActivate:[AuthguardGuard]
  },

  {
    path:'request', 
    component:RequestComponent,
    canActivate:[AuthguardGuard]
  },

  {
    path:'requestdelivery', 
    component:RequestdeliveryComponent,
    canActivate:[AuthguardGuard]
  },

  {
    path: 'payment', 
    component: PaymentComponent,
    canActivate:[AuthguardGuard]
  },

  {
    path:'nav', 
    component: NavigationComponent
  },

  {
    path:'addcard',
    component: AddcardComponent,
    canActivate:[AuthguardGuard]
  },

  {
    path: 'request-form', 
    component:RequestdeliveryformComponent,
    canActivate:[AuthguardGuard]
  },

  {
    path: 'packagepick', 
    component:RequestpackagepickedComponent,
    canActivate:[AuthguardGuard]
  },

  {
    path: 'map', 
    component:MapComponent
  },

  {
    path: 'trackdelivery', 
    component:TrackdeliveryComponent
  },

  {
    path: 'requesthistorydetails', 
    component:RequesthistorydetailsComponent,
    canActivate:[AuthguardGuard]
  },
  {
    path: 'myrequest', 
    component:RiderlogComponent,
    canActivate:[AuthguardGuard]
  },
  {
    path: 'update/profile',
    component: UpdateprofileComponent
  }

];


@NgModule({
  imports: [
    RouterModule.forRoot(routes, {
      preloadingStrategy: PreloadAllModules
    })],
  exports: [RouterModule]
})
export class AppRoutingModule { }
