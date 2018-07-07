
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

  
  
#s. note
#add r0,r1,#4 表示r0=r1+r4
#sub r0,r1,#4 表示减
#sub r0,r1,r2 表示r0=r1-r2
#bl  branch and link bl xxx 1.跳转到xxx2.把返回地址（下一条指令的地址）保存到lr寄存器
#ldm 读内存，写入多个寄存器
#stm 把多个寄存器的值写入内存
#示例：
stmdb sp!,{fp,ip,lr,pc}
假设sp=4096，db表示先减后存
先减，sp=4092
存储pc
fp等后面的都是可查r11,r12,r14,r15
先减，sp=4088
4088-4091存储lr的值
4084-4087存储ip值
4080-4083存储fp值

示例：
ldmia  sp,{fp,sp,pc}
ia表示先读后增
假设sp=4080
也是高编号寄存器存放在高地址
先读fp=4080-4083的值为原来保存的fp
后增sp'=sp+4=4084
先读sp=4084-4087的值等于原来保存的ip值
后增sp'等于4088
先读pc=4088-4091
sp'=4092

sp不带！,修改后的sp不保存进sp中