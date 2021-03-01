import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { RequestpackagepickedComponent } from './requestpackagepicked.component';

describe('RequestpackagepickedComponent', () => {
  let component: RequestpackagepickedComponent;
  let fixture: ComponentFixture<RequestpackagepickedComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ RequestpackagepickedComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(RequestpackagepickedComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
