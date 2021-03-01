import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { MainsidebarComponent } from './mainsidebar.component';

describe('MainsidebarComponent', () => {
  let component: MainsidebarComponent;
  let fixture: ComponentFixture<MainsidebarComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ MainsidebarComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(MainsidebarComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
