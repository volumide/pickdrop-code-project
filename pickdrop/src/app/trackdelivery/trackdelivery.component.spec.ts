import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { TrackdeliveryComponent } from './trackdelivery.component';

describe('TrackdeliveryComponent', () => {
  let component: TrackdeliveryComponent;
  let fixture: ComponentFixture<TrackdeliveryComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ TrackdeliveryComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(TrackdeliveryComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
