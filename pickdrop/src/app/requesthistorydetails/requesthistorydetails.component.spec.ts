import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { RequesthistorydetailsComponent } from './requesthistorydetails.component';

describe('RequesthistorydetailsComponent', () => {
  let component: RequesthistorydetailsComponent;
  let fixture: ComponentFixture<RequesthistorydetailsComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ RequesthistorydetailsComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(RequesthistorydetailsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
