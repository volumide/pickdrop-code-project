import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { RiderlogComponent } from './riderlog.component';

describe('RiderlogComponent', () => {
  let component: RiderlogComponent;
  let fixture: ComponentFixture<RiderlogComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ RiderlogComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(RiderlogComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
