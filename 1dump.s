ldr r1, [pc, #20]     ;1c     //exe 0x00-explain addr+4--read addr+8, so pc=0x00 +8   gpfcon   0x1c:56000050
mov r0 ,#256          ;0x100
str r0, [r1]           ;              //write r0(0x100) to r1(0x1c,56000050)
ldr r1, [pc, #12]      ;20
mov r0, #0
str r0, [r1]


immedia_8
0x400=1 routate to right 22bit


0x400
immedia_8   rotate=22/2    1011 0000 0001
