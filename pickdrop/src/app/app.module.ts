import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';


import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { HttpClientModule } from '@angular/common/http';
import { FormsModule } from '@angular/forms';

import { LandingComponent } from './landing/landing.component';
import { AuthsidebarComponent } from './authsidebar/authsidebar.component';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
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

import { LocationnmapComponent } from './locationnmap/locationnmap.component';
import { RiderlogComponent } from './riderlog/riderlog.component';
import { ForgetpasswordComponent } from './forgetpassword/forgetpassword.component';
import { AuthguardGuard } from './authguard.guard';
import { GooglePlaceModule } from "ngx-google-places-autocomplete";
import { UpdateprofileComponent } from './updateprofile/updateprofile.component';

@NgModule({
  declarations: [
    AppComponent,
    LandingComponent,
    AuthsidebarComponent,
    RidersignupComponent,
    CutomersignupComponent,
    SigninComponent,
    MainsidebarComponent,
    ProfileComponent,
    RequestComponent,
    RequestdeliveryComponent,
    PaymentComponent,
    NavigationComponent,
    AddcardComponent,
    RequestdeliveryformComponent,
    RequestpackagepickedComponent,
    MapComponent,
    TrackdeliveryComponent,
    RequesthistorydetailsComponent,
    LocationnmapComponent,
    RiderlogComponent,
    ForgetpasswordComponent,
    UpdateprofileComponent,
    
    
  ],
  imports: [
    GooglePlaceModule,
    BrowserModule,
    AppRoutingModule,
    BrowserAnimationsModule,
    HttpClientModule,
    FormsModule,
    
  ],
  providers: [AuthguardGuard],
  bootstrap: [AppComponent]
})
export class AppModule { }
