import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { LocationnmapComponent } from './locationnmap.component';

describe('LocationnmapComponent', () => {
  let component: LocationnmapComponent;
  let fixture: ComponentFixture<LocationnmapComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ LocationnmapComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(LocationnmapComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
