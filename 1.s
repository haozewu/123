/*
system on chip

cpu+sram+gpio+nandflash

1.nor start:nor flash base addr=0
then cpu read the first command and read other command
ram in chip addr 0x4000,000

2.nand start:4k ram base addr=0
nor flash disallowed
it will copy bin in 4k to sram
note:most of the chip start from 0 addr


led on:
*/
.text
.golbal _start

/*
  set gpf4 output
  put 0x100 to addr 0x56000050
  */
  
  ldr r1, =0x56000050
  ldr r0, =0x100   //mov r0, #0x100
  str r0, [r1]
  
  /*set gpf4 high
  write 0 to addr 0x56000054
  */
  ldr r1, =0x56000054
  ldr r0, =0//move r0, #0
  str r0, [r1]
  
  //ldr and str all false command
  
  
