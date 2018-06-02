
.text
.golbal _start

_start:
  //set memary:sp stack
  ldr sp, =4096   //nand start   
  //ldr sp, =0x40000000  //nor start    set at the top
  
  //start main
  bl main  //bl :step to run main and save return addr
halt:
  b halt
