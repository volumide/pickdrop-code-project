import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { RequestdeliveryComponent } from './requestdelivery.component';

describe('RequestdeliveryComponent', () => {
  let component: RequestdeliveryComponent;
  let fixture: ComponentFixture<RequestdeliveryComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ RequestdeliveryComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(RequestdeliveryComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
