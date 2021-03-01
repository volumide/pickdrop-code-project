import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CutomersignupComponent } from './cutomersignup.component';

describe('CutomersignupComponent', () => {
  let component: CutomersignupComponent;
  let fixture: ComponentFixture<CutomersignupComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CutomersignupComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CutomersignupComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
