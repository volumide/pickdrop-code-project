import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { RequestdeliveryformComponent } from './requestdeliveryform.component';

describe('RequestdeliveryformComponent', () => {
  let component: RequestdeliveryformComponent;
  let fixture: ComponentFixture<RequestdeliveryformComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ RequestdeliveryformComponent]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(RequestdeliveryformComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
